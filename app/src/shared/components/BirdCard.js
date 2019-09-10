import React from 'react';
import {Card, Button} from 'react-bootstrap';

export const BirdCard = (props) => {

	return (
		<>
			<Card style={{width: '18rem'}}>
				<Card.Img variant="top" src={props.image} alt={props.image}/>
				<Card.Body>
					<Card.Title>{props.title}</Card.Title>
					<Card.Text>
						{props.birdInfo}
					</Card.Text>
					<Button variant="primary">Go To Species</Button>
				</Card.Body>
			</Card>
		</>
	);
};

export default BirdCard;