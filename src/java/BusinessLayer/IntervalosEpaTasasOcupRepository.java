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
public class IntervalosEpaTasasOcupRepository {
    
    Session session = null;

    public IntervalosEpaTasasOcupRepository() {
        this.session = HibernateUtil.getSessionFactory().getCurrentSession();
    }
    
    public List getIntervalosEpaTasasOcupacion() {
        
        List<IntervalosepaTasasOcup> epatasasocup = null;
        try {
            org.hibernate.Transaction tx = session.beginTransaction();
            Query q = session.createQuery ("from IntervalosepaTasasOcup");
            epatasasocup = (List<IntervalosepaTasasOcup>) q.list();
            
        } catch (Exception e) {
            e.printStackTrace();
        }
        return epatasasocup;
    }
}
