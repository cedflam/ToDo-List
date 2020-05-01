import React, {Fragment, useState} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {ToastContainer, toast} from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
import '../css/AddTask.css';

const AddTask = () => {

    const [task, setTask] = useState({
        title: "",
        content: ""
    });

    const [errors, setErrors] = useState({
        title: "",
        content: ""
    })

    /**
     * Permet de soumettre le formulaire
     * @param event
     * @returns {Promise<void>}
     */
    const handleSubmit = async event => {
        event.preventDefault();
        try {
            const response = await axios.post('/task/new', task);
            setErrors({});
            toast.success("La tâche " + task.title + " a été ajoutée ! ");
            toast.info("Ajoutez une nouvelle tâche ou fermez la fenêtre ...")
        } catch (error) {
            if (error.response.data) {
                const apiErrors = {};
                error.response.data.violations.forEach(violation => {
                    apiErrors[violation.propertyPath] = violation.title;
                });
                setErrors(apiErrors);
            }
            toast.error("Une erreur s'est produite !")
        }
    }

    /**
     * Permet de récuperer la saisie utilisateur
     * @param currentTarget
     */
    const handleChange = ({currentTarget}) => {
        const {name, value} = currentTarget;
        setTask({...task, [name]: value});
    }


    return (
        <Fragment>
            <form className="form-group" onSubmit={handleSubmit}>
                <div>
                    <label htmlFor="titre">Titre</label>
                    <input name="title"
                           type="text"
                           className={"form-control " + ( errors.title && " is-invalid")}
                           placeholder="Saisir le titre ..."
                           value={task.title}
                           onChange={handleChange}
                    />
                    {errors && <p className="invalid-feedback">{errors.title} </p>}
                </div>

                <div>
                    <label htmlFor="description" className="mt-3">Description de la tâche</label>
                    <textarea className={"form-control " + ( errors.content && " is-invalid")}
                              name="content"
                              id=""
                              cols="30"
                              rows="5"
                              wrap="hard"
                              value={task.content}
                              onChange={handleChange}
                    />
                    {errors && <p className="invalid-feedback">{errors.content} </p>}
                </div>

                <button type="submit"
                        className="btn btn-sm btn-primary mt-2">
                    Ajouter
                </button>

            </form>
            <ToastContainer position={toast.POSITION.TOP_RIGHT}/>
        </Fragment>
    );
};

const rootElement = document.querySelector('#addTask');
ReactDOM.render(<AddTask/>, rootElement);
