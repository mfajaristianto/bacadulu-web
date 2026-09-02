<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CommentsSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_comments_table_has_required_columns(): void
    {
        $this->assertTrue(
            Schema::hasColumns('comments', [
                'id',
                'post_id',
                'user_id',
                'body',
                'created_at',
                'updated_at',
            ])
        );
    }

    public function test_comment_can_be_created(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Artikel Test',
            'slug' => 'artikel-test',
            'content' => '<p>Isi artikel test</p>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Komentar test',
        ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Komentar test',
        ]);
    }

    public function test_comment_belongs_to_user_and_post(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Artikel Relation Test',
            'slug' => 'artikel-relation-test',
            'content' => '<p>Isi artikel</p>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Komentar relasi',
        ]);

        $this->assertTrue(
            $comment->user->is($user)
        );

        $this->assertTrue(
            $comment->post->is($post)
        );
    }

    public function test_legacy_content_accessor_returns_body(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Legacy Comment Test',
            'slug' => 'legacy-comment-test',
            'content' => '<p>Isi</p>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Isi komentar compatibility',
        ]);

        $this->assertSame(
            'Isi komentar compatibility',
            $comment->content
        );
    }

    public function test_deleting_post_deletes_its_comments(): void
    {
        $user = User::factory()->create();

        $post = Post::create([
            'title' => 'Cascade Test',
            'slug' => 'cascade-test',
            'content' => '<p>Isi</p>',
            'category' => 'Teknik',
            'user_id' => $user->id,
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'body' => 'Komentar akan terhapus',
        ]);

        $commentId = $comment->id;

        $post->delete();

        $this->assertDatabaseMissing('comments', [
            'id' => $commentId,
        ]);
    }
}