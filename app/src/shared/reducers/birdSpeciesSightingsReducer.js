export default (state = [], action) => {
	switch(action.type) {
		case "GET_SIGHTINGS_BY_SIGHTING_USER_PROFILE_ID":
			return action.payload;
		default:
			return state;
	}
}