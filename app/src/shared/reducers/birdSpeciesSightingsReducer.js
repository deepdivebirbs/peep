export default (state = [], action) => {
	switch(action.type) {
		case "GET_SIGHTINGS_BY_SIGHTING_BIRD_SPECIES_ID":
			return action.payload;
		default:
			return state;
	}
}