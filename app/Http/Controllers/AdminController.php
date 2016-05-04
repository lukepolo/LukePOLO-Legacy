<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;
use DateTime;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Shows the main admin page
     * @return mixed
     */
    public function getIndex()
    {
        return view('admin.index', [
            'comments' => Comment::with('blog')->where('user_id', '!=',
                \Auth::user()->id)->whereNull('been_moderated')->get()
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function getCreate()
    {
        return view('admin.create');
    }

    /**
     * AJAX request to get the number of visits
     * @return mixed
     */
    public function getVisits()
    {
        $visitors = \LaravelAnalytics::getVisitorsAndPageViews(7);

        $analytics = null;
        foreach ($visitors as $visitor) {
            $analytics['labels'][] = $visitor['date']->toDateString();
            $analytics['visitors'][] = $visitor['visitors'];
            $analytics['views'][] = $visitor['pageViews'];
        }

        return response()->json($analytics);
    }

    /**
     * AJAX request to get the most popular pages
     * @return mixed
     */
    public function getPopularPages()
    {
        $visitors = \LaravelAnalytics::getMostVisitedPagesForPeriod(
            new DateTime('2015-05-06 00:00:00'),
            new DateTime(),
            10
        );

        return response()->json($visitors);
    }

    /**
     * AJAX request to mark a post as read
     * @return mixed
     */
    public function postMarkRead()
    {
        $comment = Comment::find(\Request::get('comment_id'));
        $comment->been_moderated = true;
        $comment->save();

        return response('Success');
    }

    /**
     * AJAX request to get a comment
     * @param $commentID
     * @return mixed
     */
    public function getComment($commentID)
    {
        $comment = Comment::find($commentID);
        if (!empty($comment)) {
            return view('admin.comment', [
                'comment' => $comment
            ])->render();
        }
    }
}