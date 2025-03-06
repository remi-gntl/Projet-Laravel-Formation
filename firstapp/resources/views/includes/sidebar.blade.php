<div class="my-4">Categories</div>
<div class="list-group">

   @foreach(App\Models\Category::get() as $category)
   <a href="{{route ('category.show', ['category'=>$category->slug])}}" class="list-group-item {{ Request::is('category/'.$category->slug) ? 'active' : ''}}">
    {{$category->name}}</a>
   @endforeach
</div>