import { PostSample } from "./PostsSample";
import PlainToRich from "@/Functions/PlainToRich";
import { Interweave } from "interweave";

const Posts = () => {
    const PostsArr = PostSample;
    return(
        <div>
            {PostsArr.map(post => <div><strong>{post.character}</strong> - <Interweave content={PlainToRich(post.msg)} /><br />{post.dateTime}</div>)}
        </div>
    )
}

export default Posts;