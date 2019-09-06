import React from 'react';
import {Button, Row, Col, Container, Card, ListGroup, ListGroupItem} from 'react-bootstrap';

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
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
									been
									the
									industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
									type
									and scrambled it to make a type specimen book. It has survived not only five centuries, but
									also
									the leap into electronic typesetting, remaining essentially unchanged. It was popularised in
									the
									1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently
									with
									desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
								</p>
							</article>
						</Col>
						<Col>
							<Card className={"dailyFeature"} style={{width: '18rem'}}>
								<Card.Img variant="top" src="holder.js/100px180"/>
								<Card.Body>
									<Card.Title>Featured Bird</Card.Title>
									<Card.Text>
										Some dynamic text about whatever bird is being displayed above.
									</Card.Text>
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