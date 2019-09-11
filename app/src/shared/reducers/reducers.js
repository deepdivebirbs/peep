import {combineReducers} from 'redux';
import speciesReducer from './speciesReducer';
import favoriteReducer from './favoriteReducer';
import userProfileReducer from './userProfileReducer';
import sightingsReducer from './birdSpeciesSightingsReducer';

export const Reducers = combineReducers({
	species: speciesReducer,
	favorite: favoriteReducer,
	userProfile: userProfileReducer,
	birdSpeciesSightings: sightingsReducer
});

export default Reducers;