import React from 'react';
import {Card, Button} from 'react-bootstrap';

export const BirdCard = (props) => {

	return (
		<>
			<Card className="transparent" style={{width: '18rem'}}>
				<Card.Img variant="top" src={props.image} alt={props.image}/>
				<Card.Body>
					<Card.Title>{props.title}</Card.Title>
					<Card.Text>
						{props.birdInfo}
					</Card.Text>
					<Button variant="primary" className="btn-success">Go To Species</Button>
				</Card.Body>
			</Card>
		</>
	);
};

export default BirdCard;