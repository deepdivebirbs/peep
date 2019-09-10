import React, {useState} from 'react';
import {getSignInState} from '../../shared/utils/signInState';

import LogInForm from './LogInForm';
import Modal from "react-bootstrap/Modal";

export const FormModal = (props) => {
	const [show, setShow] = useState(false);

	const handleClose = (props) => {
		props.show = false;
		setShow(props.show);
	};

	const handleShow = (props) => {
		props.show = true;
		setShow(props.show);
	};

	//console.log("Modal State: " + props.state);

	/*
		If user is signed in buttonText = "Sign Out"
		If user is NOT signed in buttonText = "Sign In"
	 */
	let buttonText = "";
	if(getSignInState()) {
		//console.log("User Signed In");
		buttonText = "Sign Out";
	} else {
		//console.log("User Signed Out");
		buttonText = "Sign In";
	}

	function checkSignIn() {
		if(getSignInState()) {
			setShow(false);
		}
	}


	return (
		<>
			<button type="button" className="btn btn-primary" onClick={handleShow}>{buttonText}</button>
			<Modal show={show} enforceFocus="true">
				<Modal.Dialog>
					<Modal.Header closeButton>
						<Modal.Title>Sign Into your Peep account!</Modal.Title>
					</Modal.Header>

					<Modal.Body>
						<LogInForm/>
					</Modal.Body>

					<Modal.Footer>
						<button type="button" className="btn btn-secondary" onClick={handleClose}>Close</button>
					</Modal.Footer>
				</Modal.Dialog>
			</Modal>
		</>
	);
};

export default FormModal;