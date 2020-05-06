import React, {Fragment, useEffect, useState} from 'react';
import ReactDOM from "react-dom";
import axios from "axios";
import {ToastContainer, toast} from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';
import '../css/Dashboard.css';

const Dashboard = () => {

    //Propriétés
    let complete = 0;
    let totalTasks = 0;
    let myTasks = 0;

    //States
    const [userTasks, setUserTasks] = useState([]);
    const [tasks, setTasks] = useState([]);
    const [update, setUpdate] = useState(false);
    const [board, setBoard] = useState(false);
    const [boardClass, setBoardClass] = useState("board-hide");

    //Requetes
    useEffect(() => {
        axios.get('/dashboard/findUserTasks')
            .then(response => response.data)
            .then(data => {
                setUserTasks(data);
            })
            .catch(error => toast.error("Une erreur s'est produite !"))

        axios.get('/dashboard/findAllTasks')
            .then(response => response.data)
            .then(data => {
                setTasks(data);
            })
            .catch(error => toast.error("Une erreur s'est produite !"))
    }, [update]);

    //J'alimente les variables avec les données reçues
    for (let j = 0; j < userTasks.length; j++) {
        if (userTasks[j].isDone) {
            complete++;
        } else {
            myTasks++
        }
    }
    for (let i = 0; i < tasks.length; i++) {
        if (tasks[i].isDone) {
            complete++
        } else {
            totalTasks++
        }
    }
    //Bouton de maj du dashboard
    const handleUpdate = () => {
        if (update) {
            setUpdate(false)
        } else {
            setUpdate(true)
        }
    }

    const handleBoard = () => {
        if(board){
            setBoard(false)
            setBoardClass("board-hide")
        }else{
            setBoard(true)
            setBoardClass("board")
        }
    }

    return (
        <Fragment>
           <div className="col-2 float-left board" id={boardClass} onMouseEnter={handleBoard} onMouseLeave={handleBoard}>

                <div className="card bg-light">
                    <div className="card-header ">
                        <h4>Tableau de bord  <i className="fas fa-chart-line float-right"> </i></h4>
                    </div>
                    <div className="card-body ">
                        <table className="table table-sm">

                            <tbody>
                            <tr>
                                <th scope="row">Mes tâches</th>
                                <td className="text-right">{myTasks}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total restantes</th>
                                <td className="text-right">{totalTasks}</td>
                            </tr>
                            <tr>
                                <th scope="row">Accomplies</th>
                                <td className="text-right">{complete}</td>
                            </tr>
                           <tr >
                               <th> Rafraichir </th>
                               <td>
                                   <button onClick={handleUpdate}
                                           className="btn btn-sm btn-primary  float-right">
                                       <i className="fas fa-sync float-right"> </i></button>
                               </td>
                           </tr>
                            <tr>
                                <th> </th>
                                <td> </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div className="card-footer text-center">
                        <span> &copy;ToDo-List</span>
                    </div>
                </div>
            </div>

        </Fragment>
    );
};

const rootElement = document.querySelector('#dashboard');
ReactDOM.render(<Dashboard/>, rootElement);