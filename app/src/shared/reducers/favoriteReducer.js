export default (state = [], action) => {
	switch(action.type) {
		case "getAllFavorites":
			return action.payload
		default:
			return state;
	}
}