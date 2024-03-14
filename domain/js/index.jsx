function Header({ title }) {
    return (<h3>{title ? title : 'uden titel'}</h3>);
}

function HomePage() {
    const names = ['Ada Lovelace', 'Grace Hopper', 'Margaret Hamilton'];
    
    const [likes, setLikes] = React.useState(0);

    let handleClick = () => setLikes(likes+1);
    
    return (
      <div>
        {/* Nesting the Header component */}
        <Header  title = "Development training"  />
        <ul>
            {names.map(p=> <li key={p}>{p}</li>)} 
        </ul>
        <button onClick={handleClick}>Likes ({likes})</button>
      </div>
    );
  }

const app = document.getElementById('app');
const root = ReactDOM.createRoot(app);
root.render(<HomePage />);
