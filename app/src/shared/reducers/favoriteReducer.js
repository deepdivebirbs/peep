import {httpConfig} from "../utils/http-config";

export const getAllFavorites = (test) =>async (dispatch) => {
	const payload = await httpConfig.get ("/apis/favorite");

	dispatch ({type: "getAllFavorites", payload: payload.data});
};