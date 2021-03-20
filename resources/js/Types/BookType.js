import { number, shape, string } from "prop-types";

export default shape({
    id: number,
    title: string,
    subtitle: string,
    description: string,
    preview: string,
    cover: string,
});
