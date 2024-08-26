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
		$news = News::with(['newsCategories','institution'])->orderBy('created_at','desc')->paginate(10);

		// Add reading time to each paginated news item
		$news->getCollection()->transform(function ($newsItem) {
			$newsItem->readTime = $this->readTime($newsItem->content);
			return $newsItem;
		});
		
		$newsCategories = NewsCategory::withCount('news')->orderBy('news_count','desc')->get();

       // dd($newsCategories);

		return view('news.index', compact('news','newsCategories'));
	}


	
	
	public function indexByInstitution(Institution $institution)
	{
		// Paginate the news items associated with the institution
		$news = $institution->news()->with('newsCategories')->orderBy('created_at','desc')->paginate(10);
		
		$news->getCollection()->transform(function ($newsItem) {
			$newsItem->readTime = $this->readTime($newsItem->content);
			return $newsItem;
		});
		
		$news->load(['institution']);
		
		$newsCategories = NewsCategory::withCount('news')->orderBy('news_count','desc')->get();


		return view('news.index', compact('institution','news','newsCategories'));
	}

	
	
	
	
	public function indexByNewsCategory(NewsCategory $newsCategory)
	{
		// Paginate the news items associated with the news category
		$news = $newsCategory->news()->with('newsCategories')->orderBy('created_at','desc')->paginate(10);
		
		$news->getCollection()->transform(function ($newsItem) {
			$newsItem->readTime = $this->readTime($newsItem->content);
			return $newsItem;
		});
		
		
		$news->load(['institution']);
		
		$newsCategories = NewsCategory::withCount('news')->orderBy('news_count','desc')->get();

		return view('news.index', compact('newsCategory','news','newsCategories'));
	}

	
	
	
	public function show(News $news) {
		 	 		 
			$news->readTime = $this->readTime($news->content);
		    
		return view('news.show', compact('news'));
	}
	
	
	public function showByInstitution(Institution $institution, News $news) {
		
			
			if($news->institution_id !== $institution->id){
				abort(404);
			}

			
			$news->readTime = $this->readTime($news->content);

			
		 return view('news.show', compact('news'));
	}	
	
	
	public function showByNewsCategory(NewsCategory $newsCategory, News $news) {
		 	 		 
				if(!$newsCategory->news->contains($news->id)){
					abort(404);
				}
				
				$news->readTime = $this->readTime($news->content);
		
				
		 return view('news.show', compact('newsCategory','news'));
	}
	
	
	
	protected function readTime($content){
		
		
		$content = str_word_count(strip_tags($content));
		
		$minutes = ceil($content / 200);
		
		return $minutes;
		
	}
	
	
	
	
}
