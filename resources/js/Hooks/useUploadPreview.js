import { useEffect, useState } from "react";

export default function useUploadPreview(cover) {
    const [previewFile, setPreviewFile] = useState(null);

    useEffect(() => {
        if (!cover) {
            return;
        }

        setPreviewFile(URL.createObjectURL(cover));
    }, [cover]);

    return previewFile;
}
