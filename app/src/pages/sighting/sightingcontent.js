import React, {useState} from 'react';
import axios from 'axios/index';
import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import {Container, Col, InputGroup, Form, Button, FormControl} from 'react-bootstrap';
import {httpConfig} from "../../shared/utils/http-config";
import {FormDebugger} from "../../shared/components/FormDebugger";

export const sightingcontent = () => {
	return (
		<>
			<Container>
				<Form>
					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Common Name</Form.Label>
							<Form.Control type="text" placeholder="Search Common Name"/>
						</Form.Group>

						<Form.Group as={Col}>
							<Form.Label>Scientific Name</Form.Label>
							<Form.Control type="text" placeholder="Search Scientific Name"/>
						</Form.Group>
					</Form.Row>

					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Date</Form.Label>
							<Form.Control placeholder="Date"/>
						</Form.Group>

						<Form.Group as={Col}>
							<Form.Label>Time</Form.Label>
							<Form.Control placeholder="Time"/>
						</Form.Group>
					</Form.Row>

					<Form.Row>
						<Form.Group as={Col}>
							<Form.Label>Location</Form.Label>
							<Form.Control/>
						</Form.Group>
					</Form.Row>

					<Button variant="primary" type="submit">
						Submit
					</Button>
				</Form>
			</Container>
		</>
	);
};


export default sightingcontent;