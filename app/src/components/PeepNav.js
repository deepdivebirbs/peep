import React from 'react';
import {Navbar, Nav, NavDropdown, Form, FormControl, Button} from 'react-bootstrap';
import FormModal from "./Modal";


export const PeepNav = () => {
	return (
		<>
			<Navbar bg="light" expand="lg">
				<Navbar.Brand href="#home">Peep</Navbar.Brand>
				<Navbar.Toggle aria-controls="basic-navbar-nav"/>
				<Navbar.Collapse id="basic-navbar-nav">
					<Nav className="mr-auto">
						<Nav.Link href="#home">Home</Nav.Link>
						<Nav.Link href="#link">My Profile</Nav.Link>
						<FormModal />

					</Nav>
					<Form inline>
						<FormControl type="text" placeholder="Search" className="mr-sm-2"/>
						<Button variant="outline-success">Search</Button>
					</Form>
				</Navbar.Collapse>
			</Navbar>
		</>
	);
};

export default PeepNav;