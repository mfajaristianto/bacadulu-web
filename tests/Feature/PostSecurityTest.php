<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(): User
    {
        return User::factory()->create();
    }

    public function test_script_tag_is_removed_before_saving(): void
    {
        $user = $this->createUser();

        $post = Post::create([
            'title' => 'XSS Script Test',
            'slug' => 'xss-script-test',
            'content' => '<p>Hello</p><script>alert("XSS")</script><strong>Aman</strong>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $rawContent = DB::table('posts')
            ->where('id', $post->id)
            ->value('content');

        $this->assertStringNotContainsString(
            '<script',
            strtolower($rawContent)
        );

        $this->assertStringNotContainsString(
            'alert("xss")',
            strtolower($rawContent)
        );

        $this->assertStringContainsString(
            '<strong>Aman</strong>',
            $rawContent
        );
    }

    public function test_onclick_attribute_is_removed(): void
    {
        $user = $this->createUser();

        $post = Post::create([
            'title' => 'Onclick Test',
            'slug' => 'onclick-test',
            'content' => '<p onclick="alert(1)">Klik saya</p>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $rawContent = DB::table('posts')
            ->where('id', $post->id)
            ->value('content');

        $this->assertStringNotContainsString(
            'onclick',
            strtolower($rawContent)
        );

        $this->assertStringContainsString(
            'Klik saya',
            $rawContent
        );
    }

    public function test_javascript_url_is_removed(): void
    {
        $user = $this->createUser();

        $post = Post::create([
            'title' => 'Javascript URL Test',
            'slug' => 'javascript-url-test',
            'content' => '<a href="javascript:alert(1)">Klik berbahaya</a>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $rawContent = DB::table('posts')
            ->where('id', $post->id)
            ->value('content');

        $this->assertStringNotContainsString(
            'javascript:',
            strtolower($rawContent)
        );

        $this->assertStringContainsString(
            'Klik berbahaya',
            $rawContent
        );
    }

    public function test_safe_html_is_preserved(): void
    {
        $user = $this->createUser();

        $safeHtml = '
            <h2>Judul Artikel</h2>
            <p>Ini <strong>tebal</strong> dan <em>miring</em>.</p>
            <ul>
                <li>Poin satu</li>
                <li>Poin dua</li>
            </ul>
            <a href="https://example.com">Link aman</a>
        ';

        $post = Post::create([
            'title' => 'Safe HTML Test',
            'slug' => 'safe-html-test',
            'content' => $safeHtml,
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $content = DB::table('posts')
            ->where('id', $post->id)
            ->value('content');

        $this->assertStringContainsString(
            '<h2>Judul Artikel</h2>',
            $content
        );

        $this->assertStringContainsString(
            '<strong>tebal</strong>',
            $content
        );

        $this->assertStringContainsString(
            '<em>miring</em>',
            $content
        );

        $this->assertStringContainsString(
            '<ul>',
            $content
        );

        $this->assertStringContainsString(
            '<li>Poin satu</li>',
            $content
        );

        $this->assertStringContainsString(
            'https://example.com',
            $content
        );
    }

    public function test_legacy_unsafe_content_is_sanitized_when_read(): void
    {
        $user = $this->createUser();

        /*
         * Insert langsung lewat Query Builder supaya mutator Post
         * tidak ikut membersihkan data.
         *
         * Ini mensimulasikan artikel lama yang sudah tersimpan
         * sebelum HtmlSanitizer dipasang.
         */
        $postId = DB::table('posts')->insertGetId([
            'title' => 'Legacy Unsafe Post',
            'slug' => 'legacy-unsafe-post',
            'content' => '
                <p onclick="alert(1)">Artikel lama</p>
                <script>alert("legacy-xss")</script>
                <a href="javascript:alert(2)">Bad Link</a>
                <strong>Format aman</strong>
            ',
            'category' => 'Teknik',
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /*
         * Pastikan data RAW memang masih berbahaya.
         */
        $rawContent = DB::table('posts')
            ->where('id', $postId)
            ->value('content');

        $this->assertStringContainsString(
            '<script',
            strtolower($rawContent)
        );

        /*
         * Tetapi ketika dibaca melalui Model Post,
         * accessor harus membersihkannya.
         */
        $post = Post::findOrFail($postId);

        $cleanContent = $post->content;

        $this->assertStringNotContainsString(
            '<script',
            strtolower($cleanContent)
        );

        $this->assertStringNotContainsString(
            'onclick',
            strtolower($cleanContent)
        );

        $this->assertStringNotContainsString(
            'javascript:',
            strtolower($cleanContent)
        );

        $this->assertStringContainsString(
            '<strong>Format aman</strong>',
            $cleanContent
        );
    }

    public function test_iframe_object_and_form_are_removed(): void
    {
        $user = $this->createUser();

        $post = Post::create([
            'title' => 'Dangerous HTML Test',
            'slug' => 'dangerous-html-test',
            'content' => '
                <p>Konten normal</p>
                <iframe src="https://evil.example"></iframe>
                <object data="bad.swf"></object>
                <form action="https://evil.example">
                    <input type="text">
                    <button>Kirim</button>
                </form>
            ',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $content = DB::table('posts')
            ->where('id', $post->id)
            ->value('content');

        $lower = strtolower($content);

        $this->assertStringNotContainsString(
            '<iframe',
            $lower
        );

        $this->assertStringNotContainsString(
            '<object',
            $lower
        );

        $this->assertStringNotContainsString(
            '<form',
            $lower
        );

        $this->assertStringNotContainsString(
            '<input',
            $lower
        );

        $this->assertStringNotContainsString(
            '<button',
            $lower
        );

        $this->assertStringContainsString(
            'Konten normal',
            $content
        );
    }
}