import React from 'react';
import {Row, Col, Navbar, Nav, NavDropdown, Form, FormControl, Button} from 'react-bootstrap';
import FormModal from "./Modal";


export const PeepNav = () => {
	return (
		<>
			<Navbar bg="dark" expand="lg">
				<Navbar.Brand href="/">Peep</Navbar.Brand>
				<Navbar.Toggle aria-controls="basic-navbar-nav"/>
				<Navbar.Collapse id="basic-navbar-nav">
					<Nav className="mr-auto">
						<Nav.Link href="/">Home</Nav.Link>
						<Nav.Link href="/my-profile">My Profile</Nav.Link>
						<FormModal/>

					</Nav>
					<Form inline>
						<Row className="mt-3">
							<Col>
								<Button variant="outline-success">Search</Button>
							</Col>
							<Col>
								<FormControl type="text" placeholder="Search" className="mr-sm-2"/>
							</Col>
						</Row>

					</Form>
				</Navbar.Collapse>
			</Navbar>
		</>
	);
};

export default PeepNav;