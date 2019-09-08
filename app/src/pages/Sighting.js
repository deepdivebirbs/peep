import React from 'react';
import {Button, Row, Col, Container, Card, ListGroup, ListGroupItem} from 'react-bootstrap';

export const Sighting = () => {
	return (
		//Sighting page
		<>
			<Container className={Sighting}>
				<section>
					<row>
						<h1>Enter a Sighting</h1>
							<p>Have you sighted one of our birds? Enter the details below and post your sighting!</p>

						this is where the photo upload goes

						this is where the name search goes

						//this is the picker
						let state = {
							startDate: new Date()
						};

						handleChange = date => {
						this.setState({
						startDate: date
					});
					};

						render() {
						return (
						<DatePicker
						selected={this.state.startDate}
						onChange={this.handleChange}
						/>
						);
					}
					}

					</row>
				</section>
			</Container>
	)

};