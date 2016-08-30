<?php
class CommentTest extends PHPUnit_Framework_TestCase
{
    public function testCreateWithSlashing()
    {
        $comment = new \TypeRocket\Models\WPComment();

        $data = [
            'comment_post_id' => 1,
            'comment_content' => 'Create /TypeRocket/Name \'in quotes\'',
            'comment_author' => '/TypeRocket/Namespace',
            'comment_author_email' => 'updated@example.com',
            'comment_author_url' => 'http://typerocket.com',
        ];

        update_option('comments_notify', 0, true);

        $comment->create($data);

        wp_delete_comment($comment->comment_ID, true);

        $content = $comment->getProperty('comment_content');
        $name = $comment->getProperty('comment_author');
        $email = $comment->getProperty('comment_author_email');
        $author = $comment->getProperty('comment_author_url');

        $this->assertTrue($content == $data['comment_content']);
        $this->assertTrue($name == $data['comment_author']);
        $this->assertTrue($email == $data['comment_author_email']);
        $this->assertTrue($author == $data['comment_author_url']);

        update_option('comments_notify', 1, true);
    }

    public function testUpdateWithSlashing()
    {
        $comment = new \TypeRocket\Models\WPComment();
        $comment->findById(1);

        $data = [
            'comment_content' => 'Update /TypeRocket/Name \'in quotes\'',
            'comment_author' => '/TypeRocket/Namespace',
            'comment_author_email' => 'updated@example.com',
            'comment_author_url' => 'http://typerocket.com',
        ];

        $comment->update($data);

        $content = $comment->getProperty('comment_content');
        $name = $comment->getProperty('comment_author');
        $email = $comment->getProperty('comment_author_email');
        $url = $comment->getProperty('comment_author_url');

        $comment->update([
            'comment_content' => 'Edited again /TypeRocket/Name \'in quotes\'',
        ]);

        $this->assertTrue($content == $data['comment_content']);
        $this->assertTrue($name == $data['comment_author']);
        $this->assertTrue($email == $data['comment_author_email']);
        $this->assertTrue($url == $data['comment_author_url']);
    }
}