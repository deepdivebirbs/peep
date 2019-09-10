import React from 'react';
import {Card, Button} from 'react-bootstrap';

export const BirdCard = (props) => {

	return (
		<>
			<Card style={{width: '18rem'}}>
				<Card.Img variant="top" src="holder.js/100px180"/>
				<Card.Body>
					<Card.Title>{props.title}</Card.Title>
					<Card.Text>
						{props.birdInfo}
					</Card.Text>
					<Button variant="primary">Go somewhere</Button>
				</Card.Body>
			</Card>
		</>
	);
};

export default BirdCard;