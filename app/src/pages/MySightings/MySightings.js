import React, {useEffect} from 'react';
import {Container, Row} from 'react-bootstrap';
import {useSelector, useDispatch} from "react-redux";
import {getSpeciesBysightingBirdSpeciesId} from "../../shared/actions/birdSpeciesSighting";
import {getSpeciesBySpeciesId} from "../../shared/actions/species";
import MySightingsColumns from './MySightingsColumns';


export const MySightings = (props) => {



	return (
		<>
			<Row>
				<MySightingsColumns/>
			</Row>
		</>
	);
};

export default MySightings;
