<?php

namespace App\Http\Controllers\Api\V1;

use App\Feed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class FeedsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skip = Input::get('skip');

        $feedLimit = DB::table('feeds')
            ->select(array(DB::raw('SQL_CALC_FOUND_ROWS *, categories.title as categoryTitle , feeds.title as title, feeds.id as id')))
            ->where(function($query){
                $category_id = (int) Input::get('category');
                $category_id == 0 ? $query : $query->where('category_id','=',$category_id);
            })
            ->where(function($query){
                $q = (string) Input::get('search');

                $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
                $term = str_replace($reservedSymbols, '', $q);

                $words = explode(' ', $term);

                foreach ($words as $key => $word) {
                    /*
                     * applying + operator (required word) only big words
                     * because smaller ones are not indexed by mysql
                     */
                    if (strlen($word) >= 3) {
                        $words[$key] = '*' . $word . '*';
                    }
                }

                $searchTerm = implode(' ', $words);

                !isset($q) || $q == '' ? $query : $query->whereRaw(
                    "MATCH(feeds.title, feeds.content) AGAINST(? IN BOOLEAN MODE)",
                    array($searchTerm)
                );
            })
            ->leftJoin('categories', 'categories.id', '=', 'feeds.category_id')
            ->skip($skip ?? 0)
            ->take(10)
            ->get();
        $feedCount  = DB::select( DB::raw("SELECT FOUND_ROWS() AS total;") );

        return [
            'feeds' => $feedLimit,
            'total' => $feedCount[0]->total
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
