import React from 'react';
import {Container, Row, Col} from 'react-bootstrap';

export const Footer = () => {
	var style = {
		backgroundColor: "#F8F8F8",
		borderTop: "1px solid #E7E7E7",
		textAlign: "center",
		padding: "20px",
		position: "fixed",
		left: "0",
		bottom: "0",
		height: "60px",
		width: "100%",
	};

	return (
		<>
			<footer style={style} className="footer mt-5">
				<Row>
					<Col><a href={"/"}>Home</a></Col>
					<Col><a href={"/my-profile"}>Profile</a></Col>
				</Row>
			</footer>
		</>
	);
};

export default Footer;