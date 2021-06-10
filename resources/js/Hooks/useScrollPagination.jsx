import React, { useEffect, useState } from "react";
import { Inertia } from "@inertiajs/inertia";

export default function useScrollPagination(
    paginator,
    paginatorParamName = "paginator"
) {
    const [data, setData] = useState([]);

    useEffect(() => {
        setData([...data, ...paginator.data]);
    }, [paginator]);

    const loadMore = () => {
        Inertia.visit(paginator.next_page_url, {
            only: [paginatorParamName],
            preserveState: true,
            preserveScroll: true,
        });
    };

    const LoadMoreButton = () =>
        paginator.next_page_url && (
            <div className="flex">
                <button
                    type="button"
                    onClick={loadMore}
                    className="mx-auto text-lg underline space-x-2 focus:outline-none"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        className="h-6 w-6 inline"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth={2}
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                        />
                    </svg>
                    <span>Show more...</span>
                </button>
            </div>
        );
    return {
        loadMore,
        data,
        LoadMoreButton,
    };
}
