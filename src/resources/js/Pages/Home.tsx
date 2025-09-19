import React from "react";

type Farm = {
    id: number;
    name: string;
};

type Props = {
    farms: Farm[]
};

const Home = ({ farms }) => {

    return (
        <>
            <h1>ファーム一覧</h1>
            <ul>{farms.map((farm) => {
                return <li key={farm.id}>{farm.name}</li>
            })}</ul>
        </>
    );
};

export default Home;
