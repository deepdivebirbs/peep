import {httpConfig} from "../utils/http-config";

export const getSightingsBySightingUserProfileId = (sightingUserProfileId) => async dispatch => {
	const {data} = await httpConfig.get(`/apis/sighting/?sightingUserProfileId=${sightingUserProfileId}`);
	dispatch({type: "GET_SIGHTINGS_BY_SIGHTING_USER_PROFILE_ID", payload: data})
};

export const getSpeciesBysightingBirdSpeciesId = (speciessightingBirdSpeciesId) => async dispatch => {
	const {data} = await httpConfig.get(`/apis/sighting/?sightingBirdSpeciesId=${speciessightingBirdSpeciesId}`);
	dispatch({type: "GET_SIGHTING_BY_BIRD_SPECIES_ID", payload: data});
};