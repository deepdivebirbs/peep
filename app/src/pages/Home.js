import React from 'react';
import {Button, Row, Col, Container, Card, ListGroup, ListGroupItem} from 'react-bootstrap';
import {RandomBird} from './RandomBird';

export const Home = () => {

	return (
		// Home section
		<>
			<Container className={"home"}>
				<section>
					<Row>
						<Col>
							<div className="bg-light p-3 mb-lg-5 mt-5 rounded">
								<h1>Welcome To Peep!</h1>
								<p>
									Join a community of local birdwatchers who track the birds in the region as put together by the eBirds team at Cornell University. Make an account to keep track of your sightings and build a Favorite list of birds you've already seen, or the ones you're still trying to peep.
								</p>

							<RandomBird/>
							</div>
						</Col>
						<Col></Col>
						<Col></Col>
					</Row>
				</section>
			</Container>
		</>
	);
};

export default Home;