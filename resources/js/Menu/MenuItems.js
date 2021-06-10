const menuItems = [
    {
        id: "books",
        label: "Books",
        href: route("books.index"),
        role: "*",
        components: ["Book/Index", "Book/Show", "Book/Edit"],
    },
    {
        id: "authors",
        label: "Authors",
        href: route("authors.index"),
        role: "*",
        components: ["Author/Index", "Author/Show", "Author/Edit"],
    },
];

export default menuItems;
