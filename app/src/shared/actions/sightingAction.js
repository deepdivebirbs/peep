import {httpConfig} from "../utils/http-config";

export const getSightingsBySightingUserProfileId = (sightingUserProfileId) => async dispatch => {
	const {data} = await httpConfig(`apis/sighting/${sightingUserProfileId}`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: data })
};