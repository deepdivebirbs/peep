export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_SPECIES":
			return action.payload;
		case "GET_SPECIES_BY_ID":
			return action.payload;
		default:
			return state;
	}
}