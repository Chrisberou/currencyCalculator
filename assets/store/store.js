import { configureStore, combineReducers } from "@reduxjs/toolkit";
import thunkMiddleware from 'redux-thunk';

const rootReducer = combineReducers({
    allHands: gatherReducer,
    allPlayers: activePlayerReducer,
    PlayingState: gameStateReducer,
    pot: PotStateReducer,
    lastActions: ButtonActionsReducer,
  });
  
  const middleware = [thunkMiddleware];
  
  export default configureStore({
    reducer: rootReducer,
    middleware,
  });
  