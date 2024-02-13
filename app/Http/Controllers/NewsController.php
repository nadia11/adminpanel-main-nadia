<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;


class NewsController extends Controller
{
    public function news_list()
    {
        $news_info = DB::table('event_and_news')->orderBy('created_at', 'DESC')->get();
        $manage_news = view('pages.event-and-news.news-list')->with('all_news_info', $news_info);

        return view('dashboard')->with('main_content', $manage_news);
    }


    public function new_news_save( Request $request)
    {
//        dd($request->all());
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'news_title'   => $request->news_title,
            'news_body'    => $request->news_body,
            'news_body_short' => Str::limit($request->news_body, 150),
            'news_picture' => $request->news_picture,
            'news_status'  => $request->news_status,
            'category_id'  => $request->category_id,
            'created_at'   => date('Y-m-d H:i:s'),
        );

        if ($request->hasFile('news_picture')) {
            $upload_dir = upload_path('/news' );
            $files = $request->file('news_picture');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "news_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['news_picture'] = $file_name;
        }

        DB::table('event_and_news')->insert( $data );
        return redirect('/news/news-list')->with('success', 'Created New News Successfully!');
    }

    public function edit_news(Request $request, $news_id )
    {
        if ( $request->ajax() ) {
            $news_info = DB::table('event_and_news')->where('news_id', $news_id)->first();

            return response()->json( [$news_info ] );
        }
    }


    public function update_news( Request $request )
    {
        $data = array(
            'news_title'      => $request->news_title,
            'news_body'       => $request->news_body,
            'news_body_short' => Str::limit($request->news_body, 150),
            'news_status'     => $request->news_status,
            'category_id'     => $request->category_id,
            'updated_at'      => date('Y-m-d H:i:s')
        );


        if ($request->hasFile('news_picture')) {
            $upload_dir = upload_path('/news/' );
            $files = $request->file('news_picture');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $news_picture = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $news_picture );

            if( $request->news_picture_prev ){
                //Storage::disk('local')->delete('client-news/' . $request->news_picture_prev);.
                if(file_exists($upload_dir . $request->news_picture_prev)) {
                    unlink( $upload_dir . $request->news_picture_prev );
                }
            }
            $data['news_picture'] = $news_picture;
        }else{
            $data['news_picture'] = $request->news_picture_prev;
        }
        DB::table('event_and_news')->where('news_id', $request->news_id)->update( $data );

        return redirect('/news/news-list')->with('success', 'Update News Successfully!');
    }


    public function delete_news( Request $request, $news_id)
    {
        if ( $request->ajax() ) {
            $picture = DB::table('event_and_news')->where('news_id', $news_id)->value('news_picture');

            if ($picture){
                Storage::disk('uploads')->delete('/news/'.$picture);
            }
            DB::table('event_and_news')->where('news_id', $news_id)->delete();

            return response()->json(['success' => 'News has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the News', 'status' => 'failed']);
    }


    public function change_news_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('event_and_news')->where('news_id', $request->news_id)->update( ['news_status' => $request->news_status ] );
            return response()->json(['success' => 'News Status changed successfully!', 'news_status' => $request->news_status, 'news_id'=>$request->news_id ]);
        }
    }


    public function view_news( Request $request, $news_id )
    {
        if ( $request->ajax() ) {
            $view_news = DB::table('event_and_news')->where('news_id', $news_id )->first();

            return response()->json( array( $view_news ));
        }
    }
}
