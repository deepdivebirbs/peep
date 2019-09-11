import {httpConfig} from "../utils/http-config";

export const getAllSpecies = () => async (dispatch) => {
	const payload = await httpConfig.get('apis/species/');
	dispatch({type: "GET_ALL_SPECIES", payload: payload.data});
};

export const getSpeciesBySpeciesId = (speciesId) => async (dispatch) => {
	const payload = await httpConfig.get(`/apis/species/?${speciesId}`);
	dispatch({type: "GET_SPECIES_BY_SPECIES_ID", payload: payload.data});
};