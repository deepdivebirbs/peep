import React, {useState} from 'react';

import LogInForm from './sign-in/LogInForm';
import Modal from "react-bootstrap/Modal";
import Button from "react-bootstrap/Button";

export const FormModal = () => {
	const [show, setShow] = useState(false);
	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<button type="button" className="btn btn-primary" onClick={handleShow}>Sign In</button>
			<Modal show={show} onClick={handleClose}>
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