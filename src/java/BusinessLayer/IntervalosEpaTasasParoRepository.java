/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package BusinessLayer;

import dataTier.Entities.IntervalosepaTasasOcup;
import dataTier.Entities.IntervalosepaTasasParo;
import dataTier.HibernateUtil;
import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;

/**
 *
 * @author PC
 */
public class IntervalosEpaTasasParoRepository {
 
    Session session = null;

    public IntervalosEpaTasasParoRepository() {
        this.session = HibernateUtil.getSessionFactory().getCurrentSession();
    }
    
    public List getIntervalosEpaTasasParo() {
        
        List<IntervalosepaTasasParo> epatasasocup = null;
        try {
            org.hibernate.Transaction tx = session.beginTransaction();
            Query q = session.createQuery ("from  from IntervalosepaTasasParo");
            epatasasocup = (List<IntervalosepaTasasParo>) q.list();
            
        } catch (Exception e) {
            e.printStackTrace();
        }
        return epatasasocup;
    }
}
