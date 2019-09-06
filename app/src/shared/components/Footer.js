import React from 'react';
import {Container, Row, Col} from 'react-bootstrap';

export const Footer = () => {
	return (
		<>
				<Row>
					<Col><a href={"#home"}>Home</a></Col>
					<Col><a href={"#profile-page"}>Profile</a></Col>
					<Col><a href={"#privacy-page"}>Privacy Policy</a></Col>
				</Row>
		</>
	);
};

export default Footer;