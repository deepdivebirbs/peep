import React from 'react';
import {Container, Row, Col, Jumbotron} from 'react-bootstrap';
import {RandomBird} from './RandomBird';

export const Home = () => {

	return (
		// Home section
		<>
			<Container className={"home"}>
				<section>
					<Row>
						<Col>
							<div className="  p-3 mb-lg-5 mt-5 rounded">
								<Jumbotron className="transparent" fluid>
									<Container>
										<h1>Welcome To <span id="jumbo-peep">Peep!</span></h1>
										<p>
											Join a community of local birdwatchers who track the birds in the region as put
											together by the eBirds team at Cornell University. Make an account to keep track of
											your sightings and build a Favorite list of birds you've already seen, or the ones
											you're still trying to peep.
										</p>

										<RandomBird/>
									</Container>
								</Jumbotron>
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