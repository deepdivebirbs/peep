import React, {useState} from 'react';

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

	return (
		<>
			<button type="button" className="btn btn-primary" onClick={handleShow}>Sign In</button>
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