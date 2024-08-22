<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Institution;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    public function index()
	{
		// Paginate the query results
		$news = News::paginate(10);

		// Add reading time to each paginated news item
		$news->getCollection()->transform(function ($newsItem) {
			$newsItem->readTime = $this->readTime($newsItem->content);
			return $newsItem;
		});
		
		//dd($news);

		return view('news.index', compact('news'));
	}


	
	
	public function indexByInstitution(Institution $institution)
	{
		// Paginate the news items associated with the institution
		$news = $institution->news()->paginate(10);

		return view('news.index', compact('institution', 'news'));
	}

	
	
	
	
	public function indexByNewsCategory(NewsCategory $newsCategory)
	{
		// Paginate the news items associated with the news category
		$news = $newsCategory->news()->paginate(10);

		return view('news.index', compact('newsCategory', 'news'));
	}

	
	
	
	public function show(News $news) {
		 	 		 
		 return view('news.show', compact('news'));
	}
	
	
	public function showByInstitution(Institution $institution, News $news) {
		
				$institution->news()->where('institution_id', $institution->id);
				
		 return view('news.show', compact('institution','news'));
	}	
	
	
	public function showByNewsCategory(NewsCategory $newsCategory, News $news) {
		 	 		 
				$news =	$newsCategory->news()->where('news_id', $news->id)->get();
				
		 return view('news.show', compact('newsCategory','news'));
	}
	
	
	
	protected function readTime($content){
		
		
		$content = str_word_count(strip_tags($content));
		
		$minutes = ceil($content / 200);
		
		return $minutes;
		
	}
	
	
	
	
}
