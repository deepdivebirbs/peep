import React from 'react';
import {Container, Row, Col} from 'react-bootstrap';

export default class Footer extends React.Component {
	render() {
		return(
			<div>
				<Container>
					<footer>
						<Row>
							<Col><a href={"#home"}>Home</a></Col>
							<Col><a href={"#profile-page"}>Profile</a></Col>
							<Col><a href={"#privacy-page"}>Privacy Policy</a></Col>
						</Row>
					</footer>
				</Container>
			</div>
		);
	}
}