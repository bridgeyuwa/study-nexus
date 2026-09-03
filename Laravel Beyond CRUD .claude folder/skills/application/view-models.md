# View Models

View models prepare data for views. They replace ad-hoc data passing in controllers and eliminate duplication across create/edit/index controller methods.

---

## The Problem They Solve

```php
// BAD — duplicated across create and edit
public function create()
{
    return view('blog.form', [
        'categories' => Category::allowedForUser(current_user())->get(),
        'tags'       => Tag::all(),
    ]);
}

public function edit(Post $post)
{
    return view('blog.form', [
        'post'       => $post,
        'categories' => Category::allowedForUser(current_user())->get(),
        'tags'       => Tag::all(),
    ]);
}
```

When requirements change (e.g., filter categories by user), you update in multiple places. As forms grow, controllers grow.

**Worse alternatives:**
- Putting `allowedCategories()` on the Post model — duplication at model level
- Putting it on the User model — wrong responsibility, still scattered

---

## The View Model Pattern

```php
class PostFormViewModel
{
    public function __construct(
        private User $user,
        private ?Post $post = null,
    ) {}

    public function post(): Post
    {
        return $this->post ?? new Post();
    }

    public function categories(): Collection
    {
        return Category::allowedForUser($this->user)->get();
    }

    public function tags(): Collection
    {
        return Tag::orderBy('name')->get();
    }
}
```

Clean controllers:

```php
public function create()
{
    $viewModel = new PostFormViewModel(current_user());

    return view('blog.form', compact('viewModel'));
}

public function edit(Post $post)
{
    $viewModel = new PostFormViewModel(current_user(), $post);

    return view('blog.form', compact('viewModel'));
}
```

The controller now explicitly declares what the view will receive. No hidden state.

---

## Using the View Model in Blade

```blade
{{-- Explicit property access --}}
<input value="{{ $viewModel->post()->title }}" />
<input value="{{ $viewModel->post()->body }}" />

@foreach($viewModel->categories() as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
```

---

## Implementing Arrayable (Laravel Integration)

If the view model implements `Arrayable`, you can pass it directly to `view()`:

```php
use Illuminate\Contracts\Support\Arrayable;

class PostFormViewModel implements Arrayable
{
    public function toArray(): array
    {
        return [
            'post'       => $this->post(),
            'categories' => $this->categories(),
        ];
    }
}

// Controller
return view('blog.form', $viewModel); // Laravel unpacks Arrayable automatically
```

Blade can then use `$post` and `$categories` directly:

```blade
<input value="{{ $post->title }}" />

@foreach($categories as $category)
    <option>{{ $category->name }}</option>
@endforeach
```

---

## Implementing Responsable (AJAX / JSON)

If the view model implements `Responsable`, returning it from a controller sends it as JSON:

```php
use Illuminate\Contracts\Support\Responsable;

class PostFormViewModel implements Responsable
{
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray());
    }
}

// Controller — after saving via AJAX, return fresh view model data
public function update(Request $request, Post $post)
{
    // ... update logic

    return new PostFormViewModel(current_user(), $post);
}
```

---

## View Models + Resources

View models can use API resources internally:

```php
class PostViewModel
{
    public function values(): array
    {
        return PostResource::make($this->post ?? new Post())->resolve();
    }
}
```

**View models** provide whatever data a view needs (potentially from multiple models).
**Resources** map one-to-one onto a model for API output.
They are complementary, not competing.

---

## View Models vs. View Composers

| | View Models | View Composers |
|---|---|---|
| Wiring | Explicit — in controller | Implicit — global registration |
| Discovery | Read the controller, know the data | Must know where composers are registered |
| Dependencies | Injected explicitly | Hidden in global state |
| Reusability | Pass different args, reuse class | Tied to view name |
| Testability | Instantiate and test | Requires app boot |

View composers work fine in small apps. In large apps with multiple developers, global state is dangerous — use view models.

---

## Testing View Models

```php
it('provides allowed categories for the user', function () {
    $user = UserFactory::new()->create();
    Category::factory()->count(3)->create(['allowed_for' => $user->id]);
    Category::factory()->count(2)->create(); // not allowed for this user

    $viewModel = new PostFormViewModel($user);

    expect($viewModel->categories())->toHaveCount(3);
});
```

View models are plain PHP — no HTTP needed. Direct instantiation and assertion.

---

## Package Reference

- `spatie/laravel-view-models` — base class adding Arrayable + Responsable + automatic method-to-property resolution
