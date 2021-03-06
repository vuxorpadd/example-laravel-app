<?php

namespace App\Http\Controllers;

use App\ImageService;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BookController extends Controller
{
    private string $bookCoverPath = "book-covers/";

    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware("auth", ["except" => ["index", "show"]]);
        $this->authorizeResource(Book::class, "book");
    }

    private function resizeCover(
        UploadedFile $cover
    ): \Psr\Http\Message\StreamInterface {
        return $this->imageService->resizeImage($cover, 200, 300);
    }

    private function validationRules(array $overrides = []): array
    {
        return array_merge(
            [
                "title" => "required|string|max:100",
                "author_id" => "required|exists:authors,id",
                "subtitle" => "max:200",
                "description" => "max:2500",
                "preview" => "max:2500",
                "cover" => "required|image",
            ],
            $overrides
        );
    }

    public function index(): \Inertia\Response
    {
        $paginator = Book::orderByDesc("created_at")->simplePaginate(
            config("app.settings.books.items_per_page")
        );

        abort_if($paginator->currentPage() > 1 && $paginator->isEmpty(), 404);

        return Inertia::render("Book/Index", [
            "paginator" => $paginator,
            "permissions" => [
                "create" => \Gate::allows("create", Book::class),
            ],
        ]);
    }

    public function show(Book $book): \Inertia\Response
    {
        return Inertia::render("Book/Show", [
            "book" => $book,
            "permissions" => [
                "update" => \Gate::allows("update", $book),
                "delete" => \Gate::allows("delete", $book),
            ],
        ]);
    }

    public function create()
    {
        $authors = Author::orderBy("name")->get();
        return Inertia::render("Book/Create", compact("authors"));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $cover = $request->file("cover");
        $path = $this->bookCoverPath . $cover->hashName();

        Storage::put($path, $this->resizeCover($cover));

        Book::create(["cover" => $path] + $request->all());

        return redirect(route("books.index"));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy("name")->get();
        return Inertia::render("Book/Edit", compact("book", "authors"));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Book $book)
    {
        $this->validate(
            $request,
            $this->validationRules(["cover" => "nullable|image"])
        );

        $newCover = $request->file("cover");

        $newAttributes = $request->except("cover");

        if ($newCover) {
            $newCoverPath = $this->bookCoverPath . $newCover->hashName();
            Storage::put($newCoverPath, $this->resizeCover($newCover));
            $oldCoverPath = $book->cover;
            $newAttributes = ["cover" => $newCoverPath] + $newAttributes;
        }

        $book->update($newAttributes);

        if ($newCover && Storage::exists($oldCoverPath)) {
            Storage::delete($oldCoverPath);
        }

        return redirect(route("books.show", compact("book")));
    }

    public function destroy(Book $book)
    {
        $book->delete();

        if (Storage::exists($book->cover)) {
            Storage::delete($book->cover);
        }

        return redirect(route("books.index"));
    }
}
