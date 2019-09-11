// Written by Mark Waid Jr

import React from 'react';
import {Card, Button} from 'react-bootstrap';

export const BirdCard = (props) => {

	return (
		<>
			<Card className="mx-auto m-3 transparent" style={{width: '18rem'}}>
				<Card.Img variant="top" src={props.image} alt={props.image}/>
				<Card.Body className="p-3">
					<Card.Title className="font-weight-bold">{props.commonName}</Card.Title>
					<Card.Text>
						<span className="font-weight-bold">Common Name:</span>{props.commonName}
					</Card.Text>
					<Card.Text>
						<span className="font-weight-bold">Scientific Name: </span>{props.sciName}
					</Card.Text>
					<Button href="/view-bird" variant="primary" className="btn-success">Go To Species</Button>
				</Card.Body>
			</Card>
		</>
	);
};

export default BirdCard;