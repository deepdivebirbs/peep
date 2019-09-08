import React from 'react';
import {Button, Row, Col, Container, Card, ListGroup, ListGroupItem} from 'react-bootstrap';
import LogInModal from './sign-in/LogInModal';

export const Home = () => {
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
									<Card.Title>Random Bird</Card.Title>
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