export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_SPECIES":
			return action.payload;
			break;
		default:
			return state;
	}
}