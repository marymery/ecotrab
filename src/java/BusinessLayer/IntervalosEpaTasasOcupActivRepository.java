/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package BusinessLayer;

import dataTier.Entities.IntervalosepaTasasOcup;
import dataTier.HibernateUtil;
import java.util.List;
import org.hibernate.Query;
import org.hibernate.Session;

/**
 *
 * @author PC
 */
public class IntervalosEpaTasasOcupActivRepository {
    // from IntervalosEpaTasasOcupActivRepository
     
    Session session = null;

    public IntervalosEpaTasasOcupActivRepository() {
        this.session = HibernateUtil.getSessionFactory().getCurrentSession();
    }
    
    public List getIntervalosEpaTasasOcupacionActiv() {
        
        List<IntervalosEpaTasasOcupActivRepository> epatasasocup = null;
        try {
            org.hibernate.Transaction tx = session.beginTransaction();
            Query q = session.createQuery ("from IntervalosepaTasasOcupActiv");
            epatasasocup = (List<IntervalosEpaTasasOcupActivRepository>) q.list();
            
        } catch (Exception e) {
            e.printStackTrace();
        }
        return epatasasocup;
    }
}
