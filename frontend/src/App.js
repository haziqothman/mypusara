import React, { useEffect, useState } from "react";

function App() {
    const [data, setData] = useState(null);

    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL + "/example-route")
            .then((response) => response.json())
            .then((data) => setData(data));
    }, []);

    return (
        <div>
            <h1>React Frontend with Laravel Backend</h1>
            <p>Data from API: {data ? JSON.stringify(data) : "Loading..."}</p>
        </div>
    );
}

export default App;
