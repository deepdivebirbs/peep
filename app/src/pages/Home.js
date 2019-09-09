import React, {useEffect} from 'react';
import {Button, Row, Col, Container, Card, ListGroup, ListGroupItem} from 'react-bootstrap';
import {getAllSpecies} from '../shared/actions/species';
import {useDispatch, useSelector} from "react-redux";
import {getRandomBird} from '../shared/utils/randomBird';

export const Home = () => {
	const BIRDS = useSelector(state => state.species ? state.species : []);
	const DISPATCH = useDispatch();

	const sideEffects = () => {
		DISPATCH(getAllSpecies());
	};

	const sideEffectInputs = [];

	useEffect(sideEffects, sideEffectInputs);

	let bird = getRandomBird(BIRDS);

	return (
		// Home section
		<>
			<Container className={"home"}>
				<section>
					<Row>
						<Col>
							<article>
								<h1>Welcome To Peep!</h1>
								<p>
									Join a community of local birdwatchers who track the birds in the region as put together by the eBirds team at Cornell University. Make an account to keep track of your sightings and build a Favorite list of birds you've already seen, or the ones you're still trying to peep.
								</p>
							</article>
						</Col>
						<Col>
							<Card className={"dailyFeature"} style={{width: '18rem'}}>
								<Card.Img variant="top" src="holder.js/100px180"/>
								<Card.Body>
									<Card.Title>{bird}</Card.Title>
									<Button variant="primary">View Sightings</Button>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</section>
			</Container>
		</>
	);
};

export default Home;