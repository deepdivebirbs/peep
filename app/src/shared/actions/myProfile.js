import {httpConfig} from "../utils/http-config";

export const getUserProfileById = (userProfileId) => async dispatch => {
	const {data} = await httpConfig(`apis/userprofile/${userProfileId}`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: data })
};
