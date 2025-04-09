function verif_S()
{
    cin=document.getElementById('cin').value;
    if(cin.length<8){
        alert("cin est vide");
        return false;
    }
    c=0;
    for(i=0;i<=cin.length;i++){
        if(cin.charAt(i)<="9" && cin.charAt(i)>="0"){
            c++;
        }
    }
    if(cin.length!=c){
        alert("cin invalide");
        return false;
    }

    np=document.getElementById('np').value;
    np=np.toUpperCase();
    if(np.length==0){
        alert("nom & prenom est vide");
        return false;
    }
    c=0;
    for(i=0;i<=np.length;i++){
        if(np.charAt(i)<="Z" && np.charAt(i)>="A" ||np.charAt(i)==" "){
            c++;
        }
    }
    if(np.length!=c){
        alert("nom & prenom est invalide");
        return false;
    }
}
