import { number, string } from "prop-types";
import * as PropTypes from "prop-types";

export default PropTypes.shape({
    id: number,
    title: string,
    subtitle: string,
    description: string,
    preview: string,
    cover: string,
});
