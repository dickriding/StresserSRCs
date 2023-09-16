import React, { Component } from 'react';
import Paper from '@material-ui/core/Paper';
import Typography from '@material-ui/core/Typography';
import Grid from '@material-ui/core/Grid';
import { withStyles } from '@material-ui/styles';

import FormControl from '@material-ui/core/FormControl';
import Select from '@material-ui/core/Select';

import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemText from '@material-ui/core/ListItemText';
import TextField from '@material-ui/core/TextField';

import AddCircleIcon from '@material-ui/icons/AddCircle';
import InputAdornment from '@material-ui/core/InputAdornment';
import IconButton from '@material-ui/core/IconButton';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import Checkbox from '@material-ui/core/Checkbox';

import FormGroup from '@material-ui/core/FormGroup';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Switch from '@material-ui/core/Switch';

import Button from '@material-ui/core/Button';
import ButtonGroup from '@material-ui/core/ButtonGroup';
import axios from '../handler/axios'

import ClearIcon from '@material-ui/icons/Clear';

import { getTime } from 'date-fns';

const useStyles = () => ({
    elem : {
    	padding : '1rem',
    	flexGrow : 1
    },
  	root: {
		width: '100%',
		maxWidth: '100%',
		position: 'relative',
		overflow: 'auto',
		maxHeight: '100%',
		marginTop: '1rem'
	},
	buttongrp : {
		marginTop : '1rem'
	},
})


class AddMethod extends Component {
	constructor(props) {
		super(props)
		this.state = {
			layer : 7,
			title : '',
			name : '',
			headersb : false,
			postdata : false,
			program : '',
			argument : '',
			args : [],
			main: true,
			l4 : false,
			l3 : false,
			spoofedl4 : false,
			http : false,
			description: '',
			option: false,
			getquery: false,
			cookie: false
		}
	}
	onChangeCookie = (event) => {
		const {
			cookie
		} = this.state 
		this.setState({
			cookie : !cookie
		})
	}
	onChangeGetQuery = (event) => {
		const {
			getquery
		} = this.state 
		this.setState({
			getquery : !getquery
		})
	}
	onChangeOption = (event) => {
		const {
			option
		} = this.state 
		this.setState({
			option : !option
		})
	}
	onChangeDescription = (event) => {
		this.setState({
			description: event.target.value
		})
	}
	onChangeHttp = (event) => {
		const {
			http
		} = this.state 
		this.setState({
			http : !http
		})
	}
	onChangeHeaders = (event) => {
		const {
			headersb
		} = this.state 
		this.setState({
			headersb : !headersb
		})
	}
	onChangePostData = (event) => {
		const {
			postdata
		} = this.state 
		this.setState({
			postdata : !postdata
		})
	}
	onChangeLayer = (event) => {
		this.setState({
			layer : event.target.value
		})
	}
	onChangeTitle = (event) => {
		this.setState({
			title : event.target.value
		})
	}
	onChangeName = (event) => {
		this.setState({
			name : event.target.value
		})
	}
	onChangeProgram = (event) => {
		this.setState({
			program : event.target.value
		})
	}
	onChangeArgument = (event) => {
		this.setState({
			argument : event.target.value
		})
	}
	onAddArg = (event, name) => {
		let {
			args
		} = this.state 
		args.push({
			type: name,
			arg : name.toUpperCase()
		})
		this.setState({
			args
		})
	}
	onAdd = (event) => {
		let {
			argument,
			args
		} = this.state 
		if(!argument)
			return
		args.push({
			type : 'normal',
			arg : argument
		})
		this.setState({
			args : args,
			argument : ''
		})
	}
	onClear = (event) => {
		let {
			args
		} = this.state;
		args.pop()
		this.setState({
			args
		})
	}
	onChangeCheck = (event) => {
	    this.setState({ ...this.state, [event.target.name]: event.target.checked });
	  }
	onLaunch = (event) => {
		event.preventDefault()
		const {
			layer,
			title,
			name,
			headersb,
			postdata,
			program,
			args,
			main,
			spoofedl4,
			l4,
			l3,
			http,
			description,
			getquery,
			cookie,
			option
		} = this.state
		if(!layer ||!title ||!name || !program || args.length === 0)
			return  
		let nodes = []
		if(main)
			nodes.push('main')
		if(spoofedl4)
			nodes.push('spoof')
		if(l4)
			nodes.push('l4')
		if(l3)
			nodes.push('l3')
		const token = getTime(new Date())
		axios.post(`/admin/addMethod/${token}`, {
			layer,
			title,
			name,
			headersb,
			postdata,
			program,
			args,
			nodes,
			http,
			description,
			getquery,
			cookie,
			option
		}).then( (r) => {
			if(!r.data.success)
				return
			window.location.href = "/super-secret-acp/methods";
		})
	}
	render () {
		const { classes }  = this.props;
		const {
			layer,
			title,
			name,
			headersb,
			postdata,
			program,
			argument,
			args,
			main,
			spoofedl4,
			l4,
			l3,
			http,
			description,
			cookie,
			option,
			getquery
		} = this.state
		return (
			<>
				<Grid
					item
					xs={12}
		        >	
					<Paper
						style={{
							padding: '1rem',
							display: 'flex',
							flexWrap: 'wrap'
						}}
					>
						<Grid container spacing={1}>
							<Grid
								item
								xs={6}
					        >
					        	<div className={classes.elem}>
					        		<Typography variant="button" display="block" gutterBottom>
										Add a Method.
									</Typography>
									<FormControl 
										variant="outlined" 
										fullWidth 
										margin="normal"
									>
								        <Select 
								        	native 
								        	onChange={this.onChangeLayer}
								        	value={layer}
								        >
							              <option value={3}>Layer 3</option>
							              <option value={4}>Layer 4</option>
							              <option value={7}>Layer 7</option>
							              <option value={70}>Advanced L7</option>
								        </Select>
								    </FormControl>
								    <TextField
						              variant="outlined"
						              margin="normal"
						              required
						              fullWidth
						              label="Program"
						              value={program}
						              autoFocus
						              onChange={this.onChangeProgram}
									/>
									<TextField
						              variant="outlined"
						              margin="normal"
						              required
						              fullWidth
						              multiline
						              rows={4}
						              label="Description"
						              value={description}
						              autoFocus
						              onChange={this.onChangeDescription}
									/>
									<Grid container spacing={1}>
										<Grid
											item
											sm={6}
											xs={12}
								        >
									        <TextField
								              variant="outlined"
								              margin="normal"
								              required
								              fullWidth
								              label="Title"
								              value={title}
								              autoFocus
								              onChange={this.onChangeTitle}
											/>
								        </Grid>
								        <Grid
											item
											sm={6}
											xs={12}
								        >
								        	<TextField
								              variant="outlined"
								              margin="normal"
								              required
								              fullWidth
								              label="Name"
								              value={name}
								              autoFocus
								              onChange={this.onChangeName}
											/>
								        </Grid>
								        <Grid
								        	item 
								        	xs={12}
								        >
							        	    <FormGroup row>
												<FormControlLabel
													control={
														<Checkbox
															name="main"
															checked={main}
															onChange={this.onChangeCheck}
															color="primary"
														/>
													}
													label="Main"
							      				/>
							      				<FormControlLabel
													control={
														<Checkbox
															name="l4"
															checked={l4}
															onChange={this.onChangeCheck}
															color="primary"
														/>
													}
													label="Layer 4"
							      				/>
							      				<FormControlLabel
													control={
														<Checkbox
															name="l3"
															checked={l3}
															onChange={this.onChangeCheck}
															color="primary"
														/>
													}
													label="Layer 3"
							      				/>
							      				<FormControlLabel
													control={
														<Checkbox
															name="spoofedl4"
															checked={spoofedl4}
															onChange={this.onChangeCheck}
															color="primary"
														/>
													}
													label="Spoofed L4"
							      				/>
							      			</FormGroup>
								        </Grid>
								        <Grid
											item
											xs={12}
								        >
								        	<Grid container spacing={1}>
								        		<Grid
								        			item 
								        			sm={4}
								        		>
								        			<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={http}
													            onChange={this.onChangeHttp}
													            color="primary"
													          />
													        }
													        label="HTTP"
														/>
										        	</FormGroup>
								        		</Grid>
								        		<Grid
													item
													sm={4}
										        >
										        	<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={headersb}
													            onChange={this.onChangeHeaders}
													            color="primary"
													          />
													        }
													        label="HEADERS"
														/>
										        	</FormGroup>
										        </Grid>
										        <Grid
													item
													sm={4}
										        >
										        	<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={postdata}
													            onChange={this.onChangePostData}
													            color="primary"
													          />
													        }
													        label="POST-PARAM"
														/>
										        	</FormGroup>
										        </Grid>
								        	</Grid>
								        </Grid>
								       <Grid
											item
											xs={12}
								        >
								        	<Grid container spacing={1}>
								        		<Grid
								        			item 
								        			sm={4}
								        		>
								        			<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={option}
													            onChange={this.onChangeOption}
													            color="primary"
													          />
													        }
													        label="GET/POST"
														/>
										        	</FormGroup>
								        		</Grid>
								        		<Grid
													item
													sm={4}
										        >
										        	<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={getquery}
													            onChange={this.onChangeGetQuery}
													            color="primary"
													          />
													        }
													        label="GET-QUERY"
														/>
										        	</FormGroup>
										        </Grid>
										        <Grid
													item
													sm={4}
										        >
										        	<FormGroup row>
										        		<FormControlLabel
													        control={
													          <Switch
													            checked={cookie}
													            onChange={this.onChangeCookie}
													            color="primary"
													          />
													        }
													        label="Cookie"
														/>
										        	</FormGroup>
										        </Grid>
								        	</Grid>
								        </Grid>
								        <Grid 
								        	item 
								        	xs={12}
								        >
								        	<Button 
								        		fullWidth 
								        		variant="contained"
								        		onClick={this.onLaunch}
								        	>
								        		ADD
								        	</Button>
								        </Grid>
									</Grid>
				        		</div>
				        	</Grid>
				        	<Grid
								item
								xs={6}
					        >
					        	<div className={classes.elem}>
					        		<Typography variant="button" display="block" gutterBottom>
										Set up your arguments.
									</Typography>
						        	<FormControl fullWidth variant="filled">
									  <OutlinedInput
									    id="filled-adornment-argu"
									    value={argument}
									    onChange={this.onChangeArgument}
									    endAdornment={
									      <InputAdornment position="end">
									        <IconButton
									        	onClick={this.onAdd}
												aria-label="Add"
												edge="end"
									        >
									          <AddCircleIcon />
									        </IconButton>
									        <IconButton
									        	onClick={this.onClear}
												aria-label="Clear"
												edge="end"
									        >
									          <ClearIcon />
									        </IconButton>
									      </InputAdornment>
									    }
									  />
									</FormControl>
									<ButtonGroup className={classes.buttongrp} size="small" disableElevation variant="contained" color="primary">
										<Button onClick={(event) => this.onAddArg(event, 'host')}>HOST</Button>
										<Button onClick={(event) => this.onAddArg(event, 'port')}>PORT</Button>
										<Button onClick={(event) => this.onAddArg(event, 'time')}>TIME</Button>
										<Button onClick={(event) => this.onAddArg(event, 'rest')}>OPTION</Button>
										<Button onClick={(event) => this.onAddArg(event, 'proxy')}>PROXY</Button>
									</ButtonGroup>
									<ButtonGroup className={classes.buttongrp} size="small" disableElevation variant="contained" color="primary">
										<Button onClick={(event) => this.onAddArg(event, 'headers')}>HEADERS</Button>
										<Button onClick={(event) => this.onAddArg(event, 'postdata')}>POST</Button>
										<Button onClick={(event) => this.onAddArg(event, 'getquery')}>GET</Button>
										<Button onClick={(event) => this.onAddArg(event, 'cookie')}>COOKIE</Button>
										<Button onClick={(event) => this.onAddArg(event, 'rest')}>OPTION</Button>
									</ButtonGroup>
									<List className={classes.root}>
										{args.map( (element, index) => (
											<ListItem button key={index}>
										      <ListItemText secondary={ element.type === 'normal' ? '' : 'SPECIAL'} primary={element.arg} />
										    </ListItem>)
										)}
									</List>
					        	</div>
					        </Grid>
			        	</Grid>
					</Paper >
				</Grid>
			</>
		)
	}
}
export default withStyles(useStyles)(AddMethod);