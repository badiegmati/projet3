header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 5%;
    background-color: rgba(0, 0, 0, 0.7);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.logo img {
    height: 70px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.navbar a {
    color: white;
    margin-left: 20px;
    font-weight: 500;
    transition: color 0.3s;
}
.slider {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    box-shadow: 20px 20px 20px gray;
    animation: slider 10s linear infinite;
}

/* Animation du slider */
@keyframes slider {
    0% {
        background-image: url('Image/hotel1_2.jpg');
    }

    30% {
        background-image: url('Image/hotel1_3.jpg');
    }

    60% {
        background-image: url('Image/hotel1_4.jpg');
    }

    100% {
        background-image: url('Image/hotel1_5.jpg');
    }
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.client-images img {
    width: 200px;
    height: auto;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.client-images img:window-inactive {
    width: 300px;
    height: 300px;
}

.client-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100;
    gap: 30px;
    /* Espace entre les deux sections */
    margin-top: 70px;
}

.client-info {
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    backdrop-filter: blur(55px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 40%;
}

.client-images {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    width: 55%;

    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    backdrop-filter: blur(55px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
/* Header Modernisé */
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 1rem 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
    background: linear-gradient(135deg, #4E0250 0%, #2D0170 100%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.navbar a {
    display: inline-block;
    font-size: 1.1rem;
    color: white;
    text-decoration: none;
    margin: 0 1.2rem;
    padding: 0.6rem 1.2rem;
    border-radius: 30px;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    text-align: center;
    min-width: 120px;
}

.navbar a:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    border-color: #4a90e2;
}

/* Effet "pulse" sur le lien actif */
.navbar a.active {
    animation: pulse 2s infinite;
    background: #4a90e2;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(74, 144, 226, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(74, 144, 226, 0); }
    100% { box-shadow: 0 0 0 0 rgba(74, 144, 226, 0); }
}

/* Responsive */
@media (max-width: 768px) {
    .navbar a {
        margin: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        min-width: 100px;
    }
}