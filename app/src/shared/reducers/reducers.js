import {combineReducers} from 'redux';
import speciesReducer from './speciesReducer';
import favoriteReducer from './favoriteReducer';
import userProfileReducer from './userProfileReducer';
import sightingsReducer from './sightingsReducer';

export const combinedReducers = combineReducers({
	species: speciesReducer,
	favorite: favoriteReducer,
	userProfile: userProfileReducer,
	sightings: sightingsReducer
});