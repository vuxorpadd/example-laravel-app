<?php

namespace App\Http\Controllers;

use App\ImageService;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AuthorController extends Controller
{
    private string $authorPhotosPath = "author-photos/";
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware("auth", ["except" => ["index", "show"]]);
        $this->authorizeResource(Author::class, "author");
    }

    private function resizePhoto(
        UploadedFile $photo
    ): \Psr\Http\Message\StreamInterface {
        return $this->imageService->resizeImage($photo, 300, 300);
    }

    private function validationRules(array $overrides = []): array
    {
        return array_merge(
            [
                "name" => "required|max:50",
                "birthdate" => "required|date|before:now",
                "bio" => "max:10000",
                "photo" => "required|image",
            ],
            $overrides
        );
    }

    public function index()
    {
        $paginator = Author::orderByDesc("created_at")->simplePaginate(
            config("app.settings.authors.items_per_page")
        );

        abort_if($paginator->currentPage() > 1 && $paginator->isEmpty(), 404);

        return Inertia::render("Author/Index", [
            "paginator" => $paginator,
            "permissions" => [
                "create" => \Gate::allows("create", Author::class),
            ],
        ]);
    }

    public function show(Author $author)
    {
        return Inertia::render("Author/Show", [
            "author" => $author,
            "booksPaginator" => $author
                ->books()
                ->orderByDesc("created_at")
                ->paginate(config("app.settings.books.items_per_page")),
            "permissions" => [
                "update" => \Gate::allows("update", $author),
                "delete" => \Gate::allows("delete", $author),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render("Author/Create");
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $photo = $request->file("photo");
        $photoPath = $this->authorPhotosPath . $photo->hashName();

        \Storage::put($photoPath, $this->resizePhoto($photo));

        Author::create(["photo" => $photoPath] + $request->all());
        return redirect(route("authors.index"));
    }

    public function edit(Author $author)
    {
        return Inertia::render("Author/Edit", compact("author"));
    }

    public function update(Request $request, Author $author)
    {
        $this->validate(
            $request,
            $this->validationRules([
                "photo" => "nullable|image",
            ])
        );

        $newPhoto = $request->file("photo");

        if ($newPhoto) {
            $oldPhotoPath = $author->photo;

            $newPhotoPath = $this->authorPhotosPath . $newPhoto->hashName();
            Storage::put($newPhotoPath, $this->resizePhoto($newPhoto));

            $author->photo = $newPhotoPath;
        }

        $author->update($request->except("photo"));

        if ($newPhoto && Storage::exists($oldPhotoPath)) {
            Storage::delete($oldPhotoPath);
        }

        return redirect(route("authors.show", compact("author")));
    }

    public function destroy(Author $author)
    {
        $author->delete();

        if (Storage::exists($author->photo)) {
            Storage::delete($author->photo);
        }

        return redirect(route("authors.index"));
    }
}
