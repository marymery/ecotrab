package dataTier.Entities;
// Generated 01-jul-2012 17:36:44 by Hibernate Tools 3.2.1.GA



/**
 * EpaTasasOcupActiv generated by hbm2java
 */
public class EpaTasasOcupActiv  implements java.io.Serializable {


     private Integer id;
     private int year;
     private int provResid;
     private int sexo;
     private int estudGr;
     private int edadGr;
     private double tocup;
     private double tactiv;

    public EpaTasasOcupActiv() {
    }

    public EpaTasasOcupActiv(int year, int provResid, int sexo, int estudGr, int edadGr, double tocup, double tactiv) {
       this.year = year;
       this.provResid = provResid;
       this.sexo = sexo;
       this.estudGr = estudGr;
       this.edadGr = edadGr;
       this.tocup = tocup;
       this.tactiv = tactiv;
    }
   
    public Integer getId() {
        return this.id;
    }
    
    public void setId(Integer id) {
        this.id = id;
    }
    public int getYear() {
        return this.year;
    }
    
    public void setYear(int year) {
        this.year = year;
    }
    public int getProvResid() {
        return this.provResid;
    }
    
    public void setProvResid(int provResid) {
        this.provResid = provResid;
    }
    public int getSexo() {
        return this.sexo;
    }
    
    public void setSexo(int sexo) {
        this.sexo = sexo;
    }
    public int getEstudGr() {
        return this.estudGr;
    }
    
    public void setEstudGr(int estudGr) {
        this.estudGr = estudGr;
    }
    public int getEdadGr() {
        return this.edadGr;
    }
    
    public void setEdadGr(int edadGr) {
        this.edadGr = edadGr;
    }
    public double getTocup() {
        return this.tocup;
    }
    
    public void setTocup(double tocup) {
        this.tocup = tocup;
    }
    public double getTactiv() {
        return this.tactiv;
    }
    
    public void setTactiv(double tactiv) {
        this.tactiv = tactiv;
    }




}


